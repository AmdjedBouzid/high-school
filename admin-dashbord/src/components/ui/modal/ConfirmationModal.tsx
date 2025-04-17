import { useTheme } from "../../../context/ThemeContext";
import Button from "../button/Button";
import Loader from "../../myComponnets/Loader";
import { useState } from "react";
interface ConfirmationModalProps {
  text: string;
  okText: string | React.ReactNode;
  cancelText: string | React.ReactNode;
  okColor?: string;
  cancelColor?: string;
  onOk: (id: number) => void;
  onCancel: () => void;
  classNameOkButton?: string;
  classNameNoButton?: string;
}

export default function ConfirmationModal({
  text,
  okText,
  cancelText,
  okColor = "default",
  cancelColor = "secondary",
  onOk,
  onCancel,
  classNameOkButton,
  classNameNoButton,
}: ConfirmationModalProps) {
  const { toDeleteOrUpdateEmployeeId } = useTheme();
  const [loading, setLoading] = useState(false);
  return (
    <div className="flex flex-col gap-10 p-10 items-center  w-full">
      <p className="text-base text-gray-800 dark:text-white">{text}</p>
      <div className="flex justify-end gap-3">
        <Button
          onClick={onCancel}
          className={classNameNoButton}
          disabled={loading}
        >
          {cancelText}
        </Button>
        <Button
          onClick={async () => {
            try {
              setLoading(true);
              await onOk(toDeleteOrUpdateEmployeeId); // Make sure `onOk` returns a Promise
            } finally {
              setLoading(false);
            }
          }}
          className={classNameOkButton}
          disabled={loading}
        >
          {loading ? <Loader /> : okText}
        </Button>
      </div>
    </div>
  );
}
